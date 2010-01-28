@class GalaxyOperation;
@protocol GalaxyCacheDelegate<NSObject>
- (NSData *)galaxyCachedResponseForOperation:(GalaxyOperation *)operation;
- (void)galaxySetCacheForOperation:(GalaxyOperation *)operation;
@end